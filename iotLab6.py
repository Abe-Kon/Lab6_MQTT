import paho.mqtt.client as mqtt
from iotlab6StoringToDatabase import sensor_Data_Handler


#FROM DOC NATHAN
# MQTT Settings 
MQTT_Server = "192.168.55.204"
MQTT_Path1 = "SensorTopic1"
MQTT_Path2 = "SensorTopic2"
MQTT_Port = 1883
Keep_Alive_Interval = 45

#The callback when connected
def on_connect(client, userdata, flags, rc):
	print("Connected with result code" + str(rc))
	client.subcribe(MQTT_Path1, MQTT_Path2)

def on_subscribe(mosq, obj, mid, granted_qos):
    pass

#The callback when message received and saving Data into DB Table
def on_message(mosq, obj, msg):
	# This is the Master Call for saving MQTT Data into DB
	# For details of "sensor_Data_Handler" function please refer "sensor_data_to_db.py"
	print(msg.topic +" "+ str(msg.payload))
	print("This listens to Sensor Topic 1 ")
	sensor_Data_Handler(msg.topic, msg.payload)
	# if msg.topic == "SensorTopic1":
	# 	temp = str(float(msg.payload))
	# if msg.topic == "SensorTopic2":
	# 	humidity = str(float(msg.payload))

	url = "http://192.168.193.204/GitHub/iotLab6.py?"


client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message
client.on_subscribe = on_subscribe

client.connect(MQTT_Server,int(MQTT_Port),int(Keep_Alive_Interval))

# Connect
mqtt.connect(MQTT_Server, int(MQTT_Port), int(Keep_Alive_Interval))
# Continue the network loop
mqtt.loop_forever()

