#!/usr/bin/env python

import mysql.connector

config = {
        'user': 'root',
        'password': 'root',
        #'host': 'localhost:3306',
        'unix_socket' : '/Applications/MAMP/tmp/mysql/mysql.sock',
        'database': 'inventory',
        'raise_on_warnings': True,
}

link = mysql.connector.connect(**config)
