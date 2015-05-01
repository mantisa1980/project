#!/usr/bin/env python
# -*- coding: utf-8 -*-

import pymongo
from pymongo import MongoClient
import datetime
from datetime import datetime
from const.status_code import *

class Echo(object):
    def __init__(self):
        pass
    
     # implement interface for ModuleManager
    def on_module_init(self,module_manager):
        self.database_manager = module_manager.get_class_instance('database_manager')
        module_manager.get_class_instance('nfc_server').register_command_handler("ECHO", self.on_command_callback)

    def on_command_callback(self,data):
        return STATUS_CODE_OK,data
