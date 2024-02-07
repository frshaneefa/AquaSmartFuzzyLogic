import json
import requests
import time 
import mysql.connector
import paho.mqtt.client as mqtt
import pusher
import numpy as np
import pickle

pusher_client = pusher.Pusher(app_id='1', key=u'umpfkpusher', secret=u'umpfkiot4335', cluster=u'mt1', ssl=False, host=u'10.26.30.32', port=6001)

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="aquasmart"
)

mycursor = mydb.cursor()

# Load neural network model
objectRep = open("important.picl", "rb")
mynet = pickle.load(objectRep)

# Function to save Humidity to DB Table
def goToDB():
    try:
        # api-endpoint
        URLwater_level = "http://172.20.10.5:8000/api/listlevel"
        rwater_level = requests.get(URLwater_level)
        rwater_level.raise_for_status()  # Raise an error for bad responses
        datar = rwater_level.json()
        myresult1 = datar['blocks']

        URLwater_flow = "http://172.20.10.5:8000/api/listflow"
        rwater_flow = requests.get(URLwater_flow)
        rwater_flow.raise_for_status()
        datar = rwater_flow.json()
        myresult2 = datar['blocks']

        # Set neural network inputs
        mynet.input['water_level'] = float(myresult1[0])
        mynet.input['water_flow'] = float(myresult2[0])

        mynet.compute()
        pump_activation_value = mynet.output['pump_activation']
        print(pump_activation_value)

        print(myresult1[0])
        if 0.0 <= myresult1[0] <= 3.0:
            status1 = "onled_low"
        elif 3.01 <= myresult1[0] <= 7.0:
            status1 = "onled_medium"
        elif 7.01 <= myresult1[0] <= 10.0:
            status1 = "onled_high"
        else:
            status1 = "offled"
        
        pusher_client.trigger(u'FarisChannel', u"App\Events\DeviceControlAiled", {u'Ailed': str(status1)})

        if 0 <= pump_activation_value <= 10:
            status = "onrel_low"
        elif 11 <= pump_activation_value <= 25:
            status = "onrel_medium"
        elif 26 <= pump_activation_value <= 49:
            status = "onrel_high"
        else:
            status = "offrel"

        pusher_client.trigger(u'FarisChannel', u"App\Events\DeviceControlAi", {u'Aipump': str(status)})


        def sendTelegramAlert(message):
            TOKEN = "6583300973:AAE337T-uzlYVRu0JW8mQOSQW_OTmS88ixQ"
            chat_id = "-4038087739"
            url = f"https://api.telegram.org/bot{TOKEN}/sendMessage?chat_id={chat_id}&text={message}"
            requests.get(url).json()

        if pump_activation_value >= 20:
            sendTelegramAlert("Attention: Pump activation level is above the threshold. Pump Activation Value: {}".format(pump_activation_value))

            # Insert data into the database
            sql = "INSERT INTO alarmstat (id,Value) VALUES (%s,%s)"
            val = ('', pump_activation_value)
            mycursor.execute(sql, val)
            mydb.commit()
            print("Current Data Store alarmstat")

        pusher_client.trigger(u'FarisChannel', u'App\Events\DeviceControl', {u'Alert': 'Something happen'})
        print('DATA Transferred')

    except Exception as e:
        # Log the exception for debugging
        # print(f"An error occurred: {e}")
        print(f"An error occurred !")

while True:
    goToDB()
    time.sleep(10)
