int ledpin = 18;
int motorpin = 19;

void setup() {
  pinMode(ledpin, OUTPUT);
  pinMode(motorpin, OUTPUT);
}

void loop() {
}

void motor() {
  digitalWrite(motorpin, HIGH);  // turn the LED on (HIGH is the voltage level)
  delay(1000);                   // wait for a second
  digitalWrite(motorpin, LOW);   // turn the LED off by making the voltage LOW
  delay(1000);
}

void ledcontrol() {
  digitalWrite(ledpin, HIGH);  // turn the LED on (HIGH is the voltage level)
  delay(1000);                  // wait for a second
  digitalWrite(ledpin, LOW);   // turn the LED off by making the voltage LOW
  delay(1000);                  // wait for a second
}