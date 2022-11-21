import json
import pymysql

# myphp DB Name
DB_Name =  "iotlab6.db"

# Database Manager Class

class DatabaseManager():
	def __init__(self):
		self.conn = pymysql.connect(DB_Name)
		self.conn.execute('pragma foreign_keys = on')
		self.conn.commit()
		self.cur = self.conn.cursor()
		
	def add_del_update_db_record(self, sql_query, args=()):
		self.cur.execute(sql_query, args)
		self.conn.commit()
		return

	def __del__(self):
		self.cur.close()
		self.conn.close()

#===============================================================
# Functions to push Sensor Data into Database

# Function to save Temperature to DB Table
def DHT22_Temp_Data_Handler(jsonData):
	#Parse Data 
	json_Dict = json.loads(jsonData)
	SensorID = json_Dict['Sensor']
	SensorReading = json_Dict['SensorReading']
	#Temperature = json_Dict['Temperature']
	
	#Push into DB Table
	dbObj = DatabaseManager()
	dbObj.add_del_update_db_record("insert into DHT22_Temperature_Data (SensorID) values (?)",[SensorID])
	del dbObj
	print ("Inserted Temperature Data into Database.")
	print ("")

# Function to save Humidity to DB Table
def DHT22_Humidity_Data_Handler(jsonData):
	#Parse Data 
	json_Dict = json.loads(jsonData)
	SensorID = json_Dict['Sensor_ID']
	#Data_and_Time = json_Dict['Date']
	Humidity = json_Dict['Humidity']
	
	#Push into DB Table
	dbObj = DatabaseManager()
	dbObj.add_del_update_db_record("insert into DHT22_Humidity_Data (SensorID, Humidity) values (?,?)",[SensorID, Humidity])
	del dbObj
	print ("Inserted Humidity Data into Database.")
	print ("")


#===============================================================
# Master Function to Select DB Funtion based on MQTT Topic

def sensor_Data_Handler(Topic, jsonData):
	if Topic == "SensorTopic1":
		DHT22_Temp_Data_Handler(jsonData)
	elif Topic == "SensorTopic2":
		DHT22_Humidity_Data_Handler(jsonData)	

#===============================================================
