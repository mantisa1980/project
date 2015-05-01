#!/usr/bin/env python
# -*- coding: utf-8 -*-

import json
import pymongo
import calendar
import time
import traceback
import sys
import os
import cherrypy
from const.status_code import *

class WebAPIHandler():
    exposed = True

    def __init__(self):
        self.json_eocoder = json.JSONEncoder()
        self.command_handlers = {}

    def make_response(self,cmd,status,data):
        return self.json_eocoder.encode( ( {"cmd":cmd, "status":status , "data":data } ) )

    def register_command_handler(self,command_name, command_handler):
        if command_name in self.command_handlers:
            raise Exception("Error! Command name:%s already registered!" % (command_name))
        self.command_handlers[command_name] = command_handler

    def GET(self):
        return 'Server is running normally.'

    def POST(self, post_data): #### note: do not rename post_data parameter. client should use this keyword to post to server. 
        print ("post_data element=",post_data)
        try:
            posted_json = json.loads(post_data)
            #return self.make_response(posted_json["cmd"],STATUS_CODE_OK, posted_json["data"]) # test echo 

            if 'cmd' not in posted_json or 'data' not in posted_json:
                return self.make_response("",STATUS_CODE_ERR_COMMON_FIELD,"")

            cmd  = posted_json["cmd"]
            data = posted_json["data"]
            if cmd not in self.command_handlers:
                return self.make_response(cmd,STATUS_CODE_ERR_CMD_NOT_FOUND,"")

            ret = self.command_handlers[cmd](data)
            if type(ret) == tuple:
                return self.make_response(cmd, ret[0] , ret[1])
            else:
                return self.make_json(STATUS_CODE_ERR_CMD_IMP)

        except ValueError: # non-json format
            print ("ValueError exception!", post_data, traceback.format_exc())
            return self.make_response("", STATUS_CODE_ERR_NON_JSON_FORMAT , "")

        except:
            print ("exception!", post_data, traceback.format_exc())
            return self.make_response("", STATUS_CODE_ERR_EXCEPTION , "")

class NFCServer():
    def __init__(self):
        self.web_api_handler = WebAPIHandler()
    
    # implement interface for ModuleManager
    def on_module_init(self,module_manager):
        print ("BackendWebAPIServer on_module_init, manager=", module_manager)

    def register_command_handler(self,command_name, command_handler):
        self.web_api_handler.register_command_handler(command_name, command_handler)

    def start(self):
        cherrypy.tree.mount(
            self.web_api_handler, '/api/post',
            {'/':
                {'request.dispatch': cherrypy.dispatch.MethodDispatcher()}
            }
        )

        cherrypy.config.update({
            #'server.socket_host': '127.0.0.1', 
            'server.socket_host': '0.0.0.0',
            'server.socket_port': 80,
        })
        cherrypy.engine.start()
        cherrypy.engine.block()

if __name__ == '__main__':
    x = BackendWebAPIServer()
    x.run()
    pass
