#!/usr/bin/env python
# -*- coding: utf-8 -*-

import traceback

class LogManager():
    def __init__(self):
        pass

    # implement interface for ModuleManager
    def on_module_init(self,module_manager):
        pass

    def debug(self,data):
        print ("[DEBUG] ", data)

    def error(self,data):
        print ("[ERROR] ", data)
