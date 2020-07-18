#comm_lib.py
import requests
import json
from core.utility_lib import utilityLibrary

utl = utilityLibrary()

class commManager():
    def __init__(self):
        pass

    def postData(self, rcvEndPoint, rcvDataToSend, rcvPostType):
        tmpUrl = rcvEndPoint
        tmpData = rcvDataToSend
        
        if(rcvPostType=="json"):
            tmpData = json.loads(tmpData)
            tmpResponse = requests.post(tmpUrl, json = tmpData)
        else:
            tmpResponse = requests.post(tmpUrl, data = tmpData)
        
        tmpResponse = tmpResponse.text

        return tmpResponse