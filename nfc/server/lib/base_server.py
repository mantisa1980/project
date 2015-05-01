#!/usr/bin/env python
# -*- coding: utf-8 -*-

#from bottle import Bottle,route, run, template
from bottle import Bottle,route, run,request
SERVER_VERSION = '0.0.1'

class BaseServer(object):
    def __init__(self,host_url,port):
        self.url = host_url
        self.port= port
        self.app = Bottle()
        #self.app.route('/index.html', method='GET', callback=self.hello)
        self.app.route('/nfc/get/<data>', method='GET' , callback=self.base_get_handler)
        self.app.route('/nfc/post'      , method='POST', callback=self.base_post_handler)
        self.cmd_queue = {}

    def register_command(self,cmd,handler):
        self.cmd_queue[cmd] = handler

    def start_server(self):
        self.app.run(host=self.url, port=self.port)

    def base_get_handler(self,data):
        print("base_get_handler data=",data)
        return "Hello world get:data=" + data

    def base_post_handler(self):
        cmd  = request.forms.get('cmd')
        data = request.forms.get('data')
        print("base_post_handler: cmd=", cmd, " data=", data)
        return "Server response: VER=",SERVER_VERSION, ", cmd=" + cmd + ", data=" , data

def aaa():
    print("aaa")

if __name__ =="__main__":
    server = BaseServer("127.0.0.1",5050)
    server.start_server()

    print("program exit")