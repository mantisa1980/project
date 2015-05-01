#!/usr/bin/env python
# -*- coding: utf-8 -*-

import pymongo
from pymongo import MongoClient
import datetime
from datetime import datetime
from const.status_code import *

class Login(object):
    def __init__(self):
        pass
    
     # implement interface for ModuleManager
    def on_module_init(self,module_manager):
        self.database_manager = module_manager.get_class_instance('database_manager')
        module_manager.get_class_instance('nfc_server').register_command_handler("LOGIN", self.on_command_callback)

    def on_command_callback(self,data):
    	if "username" not in data or "password" not in data:
        	return STATUS_CODE_ERR_DATA_FIELD,None

        if not data["username"] == "michael":
        	return STATUS_CODE_INVALID_USER,None

        if not data["password"] == 12345:
        	return STATUS_CODE_INVALID_PASSWORD,None

        return STATUS_CODE_OK,{"url":"next url", "token": "AAAABBBB"}
