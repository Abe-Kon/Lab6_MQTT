#include <WiFi.h>  
#include <PubSubClient.h>
#include <WiFiClientSecure.h>
#include "DHT.h"

#define uS_TO_S_FACTOR 1000000ULL
#define TIME_TO_SLEEP  60

#define DHTPIN 23
#define DHTTYPE DHT22
#define RELAY 22

DHT dht(DHTPIN, DHTTYPE);


const int trigPin = 2;
const int echoPin = 5;



//---- WiFi settings
const char* ssid = "Ak";
const char* password = "dbh10ctorn";


//---- MQTT Broker settings
const char* mqtt_server = "172.20.10.2"; // replace with your broker url

const int mqtt_port =1883;


WiFiClient espClient;
PubSubClient client(espClient);
unsigned long lastMsg = 0;

#define MSG_BUFFER_SIZE  (50)
char msg[MSG_BUFFER_SIZE];

float sensor1 = 0;
float sensor2 = 0;
int command1 =0;

const char* sensor1_topic= "esp1/Humidity";
const char*  sensor2_topic="esp1/Temperature";
//const char*  sensor3_topic="AshesiIoTTopic";

const char* command1_topic="relay";




//==========================================
void setup_wifi() {
  delay(10);
  Serial.print("\nConnecting to ");
  Serial.println(ssid);

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  //=======
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  //=======
  randomSeed(micros());
  Serial.println("\nWiFi connected\nIP address: ");
  Serial.println(WiFi.localIP());
}


//=====================================
void reconnect() {
  // Loop until we're reconnected
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    String clientId = "ESP32Client-";   // Create a random client ID
    clientId += String(random(0xffff), HEX);  //you could make this static
    // Attempt to connect
    if (client.connect(clientId.c_str())){//, mqtt_username, mqtt_password)) {
      Serial.println("connected");

      client.subscribe(command1_topic);   // subscribe the topics here
//      client.subscribe(command2_topic);   // subscribe the topics here
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");   // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}

//================================================ setup
//================================================
void setup() {
  Serial.begin(115200);
  dht.begin();
  //while (!Serial) delay(1);
  Serial.println("Setting up");
  setup_wifi();
  pinMode(BUILTIN_LED, OUTPUT);     // Initialize the BUILTIN_LED pin as an output
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  pinMode(RELAY, OUTPUT);

  esp_sleep_enable_timer_wakeup(TIME_TO_SLEEP * uS_TO_S_FACTOR);
  
  client.setServer(mqtt_server, 1883 );//mqtt_port
  client.setCallback(callback);

}


//================================================ loop
//================================================
void loop() {
  int humidity = dht.readTemperature();
  float temperature = dht.readHumidity();

  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  
  // Sets the trigPin on HIGH state for 10 micro seconds
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  
  

  
  if (!client.connected()) reconnect();
  client.loop();

  //---- example: how to publish sensor values every 5 sec
  unsigned long now = millis();
  if (now - lastMsg > 5000) {
    lastMsg = now;
    sensor1= humidity;       // replace the random value with your sensor value
    sensor2= temperature;    // replace the random value  with your sensor value
    
    publishMessage(sensor1_topic,String(sensor1),true);    
    publishMessage(sensor2_topic,String(sensor2),true);
    Serial.println("sleeping...");
    esp_deep_sleep_start();
    Serial.println("This will never be printed");
    
  }
}

//=======================================  
// This void is called every time we have a message from the broker

void callback(char* topic, byte* payload, unsigned int length) {
  String incommingMessage = "";
  for (int i = 0; i < length; i++) incommingMessage+=(char)payload[i];
  
  Serial.println("Message arrived ["+String(topic)+"]"+incommingMessage);
  
  //--- check the incomming message
    if( strcmp(topic,command1_topic) == 0){
     if (incommingMessage.equals("1")) digitalWrite(RELAY, LOW);   // Turn the RELAY on 
     else digitalWrite(RELAY, HIGH);  // Turn the RELAY off 
  }

   //  check for other commands
 /*  else  if( strcmp(topic,command2_topic) == 0){
     if (incommingMessage.equals("1")) {  } // do something else
  }
  */
}



//======================================= publising as string
void publishMessage(const char* topic, String payload , boolean retained){
  if (client.publish(topic, payload.c_str(), true))
      Serial.println("Message publised ["+String(topic)+"]: "+payload);
}