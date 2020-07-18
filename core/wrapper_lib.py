#Wrapper library
htmlWrapper = ''

class wrapperManager():
    def __init__(self):
        pass


    def headerInit(self):
        #print('HTTP/1.0 200 OK \n Content-Type: text/html \n')
        print('Content-Type: text/html \n')
        print('')
    


    def htmlTemplateWrapper(self, rcvData, rcvTemplate):        
        global htmlWrapper
        htmlTemplate        = '<html><head><title>This is my website</title></head><body>||CONTENT||</body></html>'
        htmlContentTemplate = rcvTemplate

        #Loading the template
        htmlTemplate = open("templates/default.html", "r")
        htmlTemplate = htmlTemplate.read()

        if htmlTemplate == "":
            htmlTemplate = "main_menu"

        htmlContentTemplate = open("templates/{}.html".format(htmlContentTemplate), "r")
        htmlContentTemplate = htmlContentTemplate.read()


        #From config replacements
        htmlTemplate = htmlTemplate.replace("||CHARSET||", "")
        htmlTemplate = htmlTemplate.replace("||APPTITLE||", "Agromercado")
        htmlTemplate = htmlTemplate.replace("||PAGETITLE||", "")
        htmlTemplate = htmlTemplate.replace("||ICON||", "")
        htmlTemplate = htmlTemplate.replace("||META||", "")

        if rcvData != "":
            htmlContentTemplate = htmlContentTemplate.replace("||CONTENT||", rcvData)
            htmlTemplate = htmlTemplate.replace("||CONTENT||", htmlContentTemplate)

        htmlWrapper += htmlTemplate
    
        return htmlWrapper


                              