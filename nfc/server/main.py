#!/usr/bin/env python
# -*- coding: utf-8 -*-

from module_manager import ModuleManager
from module_list import module_list_data
if __name__ == '__main__':
    mm = ModuleManager()

    for i in module_list_data:
        mm.create_class_instance(i[0], i[1], i[2], i[3] )

    # init all instances
    mm.init_all_instance()

    # start server 
    mm.get_class_instance('nfc_server').start()
