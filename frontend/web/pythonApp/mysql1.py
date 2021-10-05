import sys
import mysql.connector


ID = sys.argv[1]

mydb = mysql.connector.connect(
    host="localhost",
    user="admin_virtual",
    password="7riX3vXt4o",
    database='admin_virtual'
)

mycursor = mydb.cursor()

mycursor.execute("SELECT * FROM lesson WHERE id="+ID)

columns = mycursor.column_names
myresult = mycursor.fetchone()


dict1 = dict(zip(columns,myresult))
print(dict1)

mydb.close()
