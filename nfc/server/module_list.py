#!/usr/bin/env python
# -*- coding: utf-8 -*-

'''

note : modules in module_list_data[0] is loaded prior to module_list_data[1] , and so on. 

'''

module_list_data=[
    # object access key         package name        python module name           class name
    # library modules
    ('log_manager'            , 'lib'              ,'log_manager'              , 'LogManager'               ) ,
    ('database_manager'       , 'lib'              ,'database_manager'         , 'DatabaseManager'          ) ,
    ('nfc_server'             , 'lib'              ,'cherrypy_server'          , 'NFCServer'                ) ,

    # command handlers 
    ('echo'                   , 'command_handlers' ,'echo'                     , 'Echo'              ) ,
    ('login'                  , 'command_handlers' ,'login'                    , 'Login'             ) ,
]
