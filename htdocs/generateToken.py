#!/usr/bin/env python3.8
# -*- coding: utf-8 -*-

import base64
import binascii
from datetime import datetime
import calendar, time
import hashlib
import hmac
import sys
import getopt
import cgi

try:
	from datetime import timezone
	utc = timezone.utc
except:
	from datetime import timedelta, tzinfo
	class UTC(tzinfo):
		ZERO = timedelta(0)
		"""UTC"""
		
		def utcoffset(self, dt):
			return self.ZERO
			
		def tzname(self, dt):
			return "UTC"
		def dst(self, dt):
			return self.ZERO
	utc = UTC()
	
print("Content-type: text/html\n\n")

def to_bytes(o):
    return str(o).encode("utf-8")

class Token:
    def __init__(self, key, appID, userName, vCardFile, expires):
        self.type    = 'provision'
        self.key     = key
        self.jid     = userName + "@" + appID
        self.vCard   = ""
        self.expires = expires

    def __str__(self):
        return "Token" + {'type'    : self.type,
                          'key'     : self.key,
                          'jid'     : self.jid,
                          'vCard'   : self.vCard[:10] + "...",
                          'expires' : self.expires}.__str__()
                          
    def serialize(self):
        sep = b"\0" # Separator is a NULL character
        body = to_bytes(self.type) + sep + to_bytes(self.jid) + sep + to_bytes(self.expires) + sep + to_bytes(self.vCard)
        mac = hmac.new(bytearray(self.key, 'utf8'), msg=body, digestmod=hashlib.sha384).digest()
        ## Uncomment to debug
        ##sys.stderr.buffer.write( b"key : " + base64.b64encode(bytearray(self.key, 'utf8')) + b"\n" )print("bodyFull: " + self.type + "_" + self.jid + "_" + str(self.expires) + "_" + self.vCard);
        ##sys.stderr.buffer.write(b"bodyString: " + ("%s_%s_%s_%s" % (self.type, self.jid, str(self.expires), self.vCard)).encode("utf-8") + b"\n");
        ##sys.stderr.buffer.write( b"body: " + ("%s" % [b for b in body]).encode("utf-8") + b"\n" )
        ##sys.stderr.buffer.write( b"mac : " + base64.b64encode(mac) + b"\n" )
        ##sys.stderr.flush()
        ## Combine the body with the hex version of the mac
        serialized = body + sep + binascii.hexlify(mac)
        return serialized


form = cgi.FieldStorage()

EPOCH_SECONDS = 62167219200
key           = '4a57d5a16d4f474cbc14af7c6828ff30'
appID         = '5d69bb.vidyo.io'
userName      = str(form.getvalue("userName_py"))
vCardFile     = None
expiresInSecs = '300'
d = datetime.now()
expires = EPOCH_SECONDS + int(time.mktime(d.timetuple())) + int(expiresInSecs)

token = Token(key, appID, userName, vCardFile, expires)
serialized = token.serialize()
b64 = base64.b64encode(serialized)
print(b64.decode())
