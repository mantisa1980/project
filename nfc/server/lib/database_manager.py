#!/usr/bin/env python
# -*- coding: utf-8 -*-

import pymongo
from pymongo import MongoClient
import traceback


class DatabaseManager():
    def __init__(self):
        self.game_db_host = 'localhost'
        self.game_db_name = 'nfc'

    # implement interface for ModuleManager
    def on_module_init(self,module_manager):
        mc = MongoClient(self.game_db_host)
        self.game_database =  mc[self.game_db_name]

    def insert_raw_data(self,collection_name, data):
        self.game_database[collection_name].insert(data)

if __name__ == '__main__':
    pass