#include <Wire.h>
#include <Keypad.h>
#include <LiquidCrystal_I2C.h>
#include "ESP8266.h"


#define SSID        "HUWWAAAAAWWW"
#define PASSWORD    "88888888"
#define HOST_NAME   "192.168.43.48"
#define HOST_PORT   (80)

const int trigPin = 9;
const int echoPin = 10;

LiquidCrystal_I2C lcd(0x27, 20, 4);

String pad;
const byte ROWS = 4; //four rows
const byte COLS = 4; //four columns

int bottlecount = 0;
//define the cymbols on the buttons of the keypads
char hexaKeys[ROWS][COLS] = {
  {'1','2','3','A'},
  {'4','5','6','B'},
  {'7','8','9','C'},
  {'*','0','#','D'}
};

byte colPins[COLS] = {26, 27, 28, 29}; //connect to the row pinouts of the keypad
byte rowPins[ROWS] = {22, 23, 24, 25}; //connect to the column pinouts of the keypad

ESP8266 wifi(Serial1);

bool ultrasonic = true;
//initialize an instance of class NewKeypad
Keypad customKeypad = Keypad(makeKeymap(hexaKeys), rowPins, colPins, ROWS, COLS); 


void setup() {
  // put your setup code here, to run once:
    lcd.begin();
    lcd.backlight();
    Serial.begin(9600);
    Serial1.begin(115200);
    setupWIFI();
}

void setupWIFI(){
  lcd.print("Connecting to WI-FI");
  lcd.setCursor(0,1);
  lcd.print(SSID);
  if (wifi.joinAP(SSID, PASSWORD)) {    
       lcd.clear();
       lcd.print("Connected");
       wifi.disableMUX();
       delay(1000);
       lcd.setCursor(0,2);
       lcd.print("Attempting to connect");
       lcd.setCursor(0,3);
       lcd.print(HOST_NAME);
       uint8_t buffer[1024] = {0};
       if (wifi.createTCP(HOST_NAME, HOST_PORT)) {
         lcd.clear();
         lcd.print("Connected to Apache");
         lcd.setCursor(0,1);
         lcd.print(HOST_NAME);
         lcd.print(":");
         lcd.print(HOST_PORT);
         delay(3000);
         lcd.clear();
         lcd.print("Hello, WELCOME!");
         lcd.setCursor(0,1);
         lcd.print("Bottle Count: ");
         lcd.setCursor(0,2);
         lcd.print("Enter ID#: ");
          
         lcd.setCursor(15,1);
         lcd.print(bottlecount);
         wifi.releaseTCP();
       } else {
         lcd.clear();
         lcd.print("Error Connection 2");
       }
  } 
  else {
    lcd.clear();
    lcd.print("Error Connection 3");
  } 
}

void loop() {
  // put your main code here, to run repeatedly:
char customKey = customKeypad.getKey();
pad+=String("");
  lcd.setCursor(11,2);
  if(customKey){
    if((customKey != 'A') && (customKey != 'B') && (customKey != 'C') && (customKey != 'D') && (customKey != '#') && (customKey != '*')){
       if(pad.length() < 5){
        pad+=String(customKey);
        lcd.print(pad);
       }
    }
    
    if(customKey == 'A'){
      int length = pad.length();
      pad.remove(length-1, 1);
      lcd.setCursor(11,2);
      lcd.print("         ");
      lcd.setCursor(11,2);
      lcd.print(pad);
    }

    if(customKey == 'B'){
      bottlecount = 0;
      lcd.setCursor(15,1);
      lcd.print("     ");
      lcd.setCursor(15,1);
      lcd.print(bottlecount);
      pad.remove(0, 5);
      lcd.setCursor(11,2);
      lcd.print("         ");
      lcd.setCursor(11,2);
      lcd.print(pad);
    }

    if(customKey == 'D'){
      wifi.createTCP(HOST_NAME, HOST_PORT);
      uint8_t buffer[1024] = {0};
      char *urls = "GET /bottleforfinesfinal/submit.php?b=";
      char *urlm = "&i=";
      char *urle = "HTTP/1.1\r\nHost: 192.168.43.48\r\nConnection: close\r\n\r\n";

     String url = urls + String(bottlecount) + urlm + pad + urle;
     const char *request = url.c_str();
      //char *hello = request.c_str();
      wifi.send((const uint8_t*)request, strlen(request));
  
      uint32_t len = wifi.recv(buffer, sizeof(buffer), 10000);
      if (len > 0) {
          for(uint32_t i = 218; i < len; i++) {
              lcd.clear();
              lcd.print((char)buffer[i]);
          }   
      }
      delay(3000);
      bottlecount = 0;
      pad = "";
      lcd.clear();
      lcd.print("Hello, WELCOME!");
      lcd.setCursor(0,1);
      lcd.print("Bottle Count: ");
      lcd.setCursor(0,2);
      lcd.print("Enter ID#: "); 
    }
  }
  
  int tbsensor = analogRead(A0);
  if(tbsensor > 700){
    //output green, servo will open for bottle insert

    bottlecount++;
    lcd.setCursor(15,1);
    lcd.print(bottlecount);
    delay(1000);
    // will depend on the falling of bottle and closing of servo
  }
  else{
    //output red, servo will not open for bottle insert

  }
}
