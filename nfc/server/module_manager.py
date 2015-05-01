#!/usr/bin/env python
# -*- coding: utf-8 -*-

class ModuleManager(object):
    def __init__(self):
        self.class_list = { }

    
    def has_id(self,id_str):
        if id_str in self.class_list:
            return True
        return False

    def __add_class_instance(self,id_str,class_instance):
        self.class_list[id_str] = class_instance
        #print ("class list=",self.class_list)

    def __load_module(self, package_name , module_name): # dynamic import 
        print ("package=",package_name)
        print ("module=",module_name)

        pkg = __import__(name=package_name, fromlist=[module_name])
        #print ("pkg=",pkg)
        python_module = getattr(pkg, module_name) # equal to pkg.module_name
        #print ("python_module=",python_module)
        return python_module

    def get_class_instance(self,id_str):
        if self.has_id(id_str):
            return self.class_list[id_str]
        else:
            raise Exception("[ModuleManager] Cannot find class identifier:", id_str)

    def create_class_instance(self, id_str, package_name ,module_name, class_name, *args):
        if self.has_id(id_str):
            raise Exception ("Error! class identifier already used:%s" % (id_str) )

        python_module = self.__load_module(package_name ,module_name)
        class_instance = getattr(python_module,class_name)(*args)
        print ("creating class instance:",class_instance)
        self.__add_class_instance(id_str,class_instance)
        return class_instance

    def init_all_instance(self): # a must-have interface that all modules should implement
        for key in self.class_list:
            obj = self.class_list[key]
            if not hasattr(obj, 'on_module_init'):
                raise Exception ("Error! on_module_init method is not implemented!class type=%s" % ( str(obj) ) )

            obj.on_module_init(self)

if __name__ == '__main__':
    pass
