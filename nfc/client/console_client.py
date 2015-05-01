#!/usr/bin/env python
# -*- coding: utf-8 -*-

import urllib2
import urllib
import json # as json
import base64
import hashlib # import md5
import hmac
from datetime import *
import time

_key = '1ecf471c9b66a2b353c2af60f231e8f0'
_mac = 'C2-2C-03-1F-1F-69' # '08-00-27-59-B4-61' 'C4-2C-03-1F-1F-69'
url = "http://127.0.0.1/api/post"
def post(url, data):
    req = urllib2.Request(url)
    d = urllib.urlencode(data)
    #enable cookie
    opener = urllib2.build_opener(urllib2.HTTPCookieProcessor())
    response = opener.open(req, d)
    return response.read()

def make_post_data(data): # encode the data, not including the post_data key
    return {'post_data': json.JSONEncoder().encode(data) }
    #return {'post_data': data }  # non-json error test


def do_ECHO():
    data = {
            "cmd":"ECHO",
            "token":"",
            "data": {
                "echo":"wooooooooo!",
            }
    }
    r = post(url,make_post_data(data))
    print r

def do_LOGIN():
    data = {
            "cmd":"LOGIN",
            "token":"",
            "data": {
                "username":"michael",
                "password":12345,
            }
    }
    r = post(url,make_post_data(data))
    print r

if __name__ == "__main__":
    do_ECHO()
    do_LOGIN()


