#!/usr/bin/python3
#Main endpoint caller
import cfg.maincfgs
import os
import cgi
import cgitb
import json

from core.wrapper_lib import wrapperManager
from core.comm_lib import commManager
from core.utility_lib import utilityLibrary

#Main variables
cgitb.enable()
wm                  = wrapperManager()
comm                = commManager()
utl                 = utilityLibrary()
htmlStr             = ""
htmlContentTemplate = "main_menu"
dataToWrap          = ""


def endpointLoader():
    global htmlStr, htmlContentTemplate, dataToWrap

    #Getting the content
    reqData = utl.formLoader(cgi.FieldStorage())
    dataToWrap = "<b>Welcome to bagdag {}</b>"

    if utl.getMethod() in utl.getValidMethods() and len(reqData) > 0:
        dataToWrap = comm.postData(cfg.maincfgs.xbarcfg["xbar_endpoint"], reqData["request_data"], "json")
        htmlContentTemplate = "default_content"
        #Call the endpoint and request the result
        dataToWrap = json.loads(dataToWrap)
        dataToWrap = dataToWrap["routers"]["response_data"]["html"]
    else:
        #No data goes to the main
        reqData = {}


    #Building the data to wrap
    wm.headerInit()
    htmlStr += wm.htmlTemplateWrapper(dataToWrap, htmlContentTemplate)    
    print(htmlStr)
    


if __name__ == '__main__':
    endpointLoader()