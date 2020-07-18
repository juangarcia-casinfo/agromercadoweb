#Utility lib
import os

class utilityLibrary():
    def __init__(self):
        pass


    #General Utilities
    def converToJSON(self, rcvDict):
        pass


    #Form Utility methods
    def getMethod(self):
        return os.environ['REQUEST_METHOD']


    def getValidMethods(self):
        return ["GET", "POST"]


    def formLoader(self, rcvRequest):
        tmpData = {}
        
        for key in rcvRequest:
            tmpData[key] = rcvRequest.getvalue(key)
            
        return tmpData


    def identifyRequest(self):
        pass


    