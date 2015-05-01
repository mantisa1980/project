#!/usr/bin/env python
# -*- coding: utf-8 -*-

import MySQLdb

class MysqlConnector(object):
    def __init__(self,):
        self.database = None
        self.cursor = None

    def connect(self,host,user,passwd,db_name):
        self.database = MySQLdb.connect(host=host, user=user, passwd=passwd, db=db_name)
        self.cursor = self.database.cursor()

    def get_query_result(self, query):
        self.cursor.execute(query)
        result = self.cursor.fetchall()
        return result

    def insert(self,row):
        pass

if __name__ =="__main__":
    
    '''
    mysql_conn = MysqlConnector()
    mysql_conn.connect("127.0.0.1", "root", "root", "NFC_TEST")

    data_set = mysql_conn.get_query_result("SELECT * FROM test")

    for record in data_set:
        print record[0]
    '''

    conn = MySQLdb.connect(host="127.0.0.1", user="root", passwd="root", db="NFC_TEST")
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM test")

    data_set = cursor.fetchall()

    for i in data_set:
        print i

    print(type(conn) ,type(cursor) ,type(data_set) )

    #cursor.execute("""
    #    INSERT INTO test(name) VALUES('Bob')
    #""")

    cursor.close() # important 

    



