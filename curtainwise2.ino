/*
 * Curtainwise by  Riho Marten Pallum
 * TO DO: Make it so that it doesn't need the delay to stop
 * 
 * 
 * NOTES: 
 * Motors need a high currrent to start, but after that they can run on a lower current ( LOWER limit start: 125; LOWER limit run: 90)
 * Direction of rotation of motor depends on wiring
 * Second motor starts spinning later due to delay in motor startup
 * 
 * PROCESS:
 * 30/03 finished first draft of code, 2 working motors
 * 31/03 started work on curtain pulling mechanism
 */


#include <WiFi.h>
#include <Stepper.h>

IPAddress server{127,0,0,1};

WiFiClient client; 

//__________PIN DEFINITIONS_____________
const int PWM1 = 3; // TWO big motors to move curtains. mot A
const int PWM2 = 11; // mot B
const int DIR1 = 12;  // Direction of motor anti-clockwise? mot A
const int DIR2 = 13;  // Direction of motor clockwise?  mot B
const int BRK1 = 9;
const int BRK2 = 8;
const int BUT1 = 6; // pin nihkenupule, lahti või kinni
const int IR_input = A3;



//___________VARIABLES USED IN PROGRAM___________________
int lahti = 0; // are the curtains open or not, 0 = not initialised, 1 = open, 2 = closed
int vel = 255; // speed at which the curtains open
int nihkedelay = 1500; // delay after which the movement stops, NOT VERY GOOD TO USE
boolean locked = false;

//_____________________WIFI_Variabes____________________________
char ssid[] = "";
char pass[] = "";

int status = WL_IDLE_STATUS;

String getSunrise;
String getSunset;
//_______________________FUNCTIONS______________________________

void RunA(int MOT,int DIR,int BRK){   //Drives motors in one direction
      digitalWrite(BRK,LOW);
      digitalWrite(DIR,HIGH);
      digitalWrite(MOT,255);
      delay(250);
      analogWrite(MOT,vel);
}
void RunB(int MOT,int DIR,int BRK){   // Drives motors in other direction
      digitalWrite(BRK,LOW);
      digitalWrite(DIR,LOW);
      digitalWrite(MOT,255);
      delay(250);
      analogWrite(MOT,vel);
}


void Stop(int MOT){
  digitalWrite(MOT,LOW);
}

void Move(){
  switch(lahti){
    case 1: //if open do this
      Serial.println("case 1");
      RunA(PWM1,DIR1,BRK1);
      RunB(PWM2,DIR2,BRK2);
      delay(nihkedelay);
      Stop(PWM1);
      Stop(PWM2);
      lahti = 2;
      break;
    case 2: //if closed do this
      Serial.println("case 2");
      RunB(PWM1,DIR1,BRK1);
      RunA(PWM2,DIR2,BRK2);
      delay(nihkedelay);
      Stop(PWM1);
      Stop(PWM2);
      lahti = 1;
      break;
    default:
      Serial.println("default");
      Stop(PWM1);
      Stop(PWM2);
  }
}

//_______________________MAIN AND SETUP__________________________
void setup() {
  pinMode(PWM1,OUTPUT);
  pinMode(DIR1,OUTPUT); //Initiates Motor Channel A pin
  pinMode(BRK1,OUTPUT);
  
  pinMode(PWM2,OUTPUT);
  pinMode(DIR2,OUTPUT); //Initiates Motor Channel A pin
  pinMode(BRK2,OUTPUT);
  
  pinMode(BUT1,INPUT_PULLUP);
  Serial.begin(9000);
  lahti = 1;
  
  while (status != WL_CONNECTED) {
    Serial.print("Attempting to connect to Network named: ");
    Serial.println(ssid);
    status = WiFi.begin(ssid, pass);
    delay(10000);
  }
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());
  IPAddress ip = WiFi.localIP();
  IPAddress gateway = WiFi.gatewayIP();
  Serial.print("IP Address: ");
  Serial.println(ip);
  
}

void loop(){
  if(digitalRead(BUT1) == LOW){
    Move();
  }  
}
