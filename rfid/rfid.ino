#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>
#include <ArduinoHttpClient.h>

#define SS_PIN 15
#define RST_PIN 16

const char *ssid = "MODALBOSS"; //ganti nama wifi
const char *pass = "samuraii";//ganti password
WiFiClient wifi;

char serverAddress[] = "192.168.3.3";  // server address
int port = 80;
HttpClient client = HttpClient(wifi, serverAddress, port);
MFRC522 rfid(SS_PIN, RST_PIN); // Instance of the class


MFRC522::MIFARE_Key key;

// Init array that will store new NUID
byte nuidPICC[4];
String UIDNumber = "";

void setup() {
   Serial.begin(9600);
   Serial.print(" Menghubungkan ke : ");
Serial.println(ssid);
WiFi.begin(ssid, pass);
while (WiFi.status() != WL_CONNECTED)
{
delay(500);
Serial.print("....");
}
Serial.print("\n");
Serial.print("IP address : ");
Serial.print(WiFi.localIP());
Serial.print("\n");
Serial.print("MAC : ");
Serial.println(WiFi.macAddress());
Serial.println("");
Serial.print("Terhubung dengan : ");
Serial.println(ssid);

  SPI.begin(); // Init SPI bus
  rfid.PCD_Init(); // Init MFRC522
  Serial.println();
  Serial.print(F("Reader :"));
  rfid.PCD_DumpVersionToSerial();

  for (byte i = 0; i < 6; i++) {
      key.keyByte[i] = 0xFF;
  }
  Serial.println();
  Serial.println(F("This code scan the MIFARE Classic NUID."));
  Serial.print(F("Using the following key:"));
  printHex(key.keyByte, MFRC522::MF_KEY_SIZE);
}

void loop() {

  // Reset the loop if no new card present on the sensor/reader. This saves the entire process when idle.
  if ( ! rfid.PICC_IsNewCardPresent())
      return;

  // Verify if the NUID has been readed
  if ( ! rfid.PICC_ReadCardSerial())
      return;

  Serial.print(F("PICC type: "));
  MFRC522::PICC_Type piccType = rfid.PICC_GetType(rfid.uid.sak);
  Serial.println(rfid.PICC_GetTypeName(piccType));

  // Check is the PICC of Classic MIFARE type
  if (piccType != MFRC522::PICC_TYPE_MIFARE_MINI &&
          piccType != MFRC522::PICC_TYPE_MIFARE_1K &&
          piccType != MFRC522::PICC_TYPE_MIFARE_4K) {
      Serial.println(F("Your tag is not of type MIFARE Classic."));
      return;
  }

  if (rfid.uid.uidByte[0] != nuidPICC[0] ||
          rfid.uid.uidByte[1] != nuidPICC[1] ||
          rfid.uid.uidByte[2] != nuidPICC[2] ||
          rfid.uid.uidByte[3] != nuidPICC[3] ) {
      Serial.println(F("A new card has been detected."));

      // Store NUID into nuidPICC array
      for (byte i = 0; i < 4; i++) {
          nuidPICC[i] = rfid.uid.uidByte[i];
      }

      Serial.println(F("The NUID tag is:"));
      Serial.print(F("In hex: "));
      UIDNumber = printHex(rfid.uid.uidByte, rfid.uid.size);
      Serial.println(UIDNumber);
      sendUID(UIDNumber);
      Serial.println();
      Serial.print(F("In dec: "));
      printDec(rfid.uid.uidByte, rfid.uid.size);
      Serial.println();
  }
  else Serial.println(F("Card read previously."));

  // Halt PICC
  rfid.PICC_HaltA();

  // Stop encryption on PCD
  rfid.PCD_StopCrypto1();
}


/**
    Helper routine to dump a byte array as hex values to Serial.
*/
String printHex(byte *buffer, byte bufferSize) {
  String UID = "";
  for (byte i = 0; i < bufferSize; i++) {
      Serial.print(buffer[i] < 0x10 ? " 0" : " ");
      UID += String(buffer[i], HEX);
      UID += ":";
      Serial.print(buffer[i], HEX);
  }
  return UID;
}

/**
    Helper routine to dump a byte array as dec values to Serial.
*/
void printDec(byte *buffer, byte bufferSize) {
  for (byte i = 0; i < bufferSize; i++) {
      Serial.print(buffer[i] < 0x10 ? " 0" : " ");
      Serial.print(buffer[i], DEC);
  }
}

void sendUID(String UID) {
  Serial.println("making POST request");
  String contentType = "application/x-www-form-urlencoded";
  String postData = "uid=";
  postData += UID;

  client.post("/RFIDGloria/insert.php", contentType, postData);

  // read the status code and body of the response
  int statusCode = client.responseStatusCode();
  String response = client.responseBody();

  Serial.print("Status code: ");
  Serial.println(statusCode);
  Serial.print("Response: ");
  Serial.println(response);
}
