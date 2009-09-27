from urllib import *
from httplib import *
from BeautifulSoup import BeautifulSoup, Comment
import re
from json import JSONDecoder
import base64
from CataTwitterConstants import *

class TwitterUser(object):
    def __init__(self, id=None, screen_name=None):
        self.id = id
        self.screen_name = screen_name
    

class CataTwitUser():


    def getFriends(self, user):
        if not isinstance(user,  TwitterUser):
            raise RuntimeError('Invalid user specified')

        id, screen_name = user.id, user.screen_name

        if id is None and screen_name is None:
            raise RuntimeError('Invalid user specified')

        if id is None:
            use = '?screen_name=' + screen_name
        else:
            use = '?user_id=' + str(id)

        def my_f(url, fp, errcode, errmsg, headers, data):
            return
        
        f = FancyURLopener()
        
        f.http_error_401 = my_f
        
        try:
            f = f.open(FRIENDS_URL + use)
            result = getJSONResponse(f)
        except:
            return []
        finally:
            f.close()
        
        
        return result


    def searchHashtagJSON( self, query, rpp, page ):

        if query[0] != '#' or len(query.split()) != 1:
            print 'Not a valid hashtag'
            return
	    
	    # I remove the # symbol

	    query = query[1:]
	    
	    f = urlopen(SEARCH_URL % 'json' + "%23" + query + 
		RPP_PARAMETER + str(rpp) + PAGE_PARAMETER + str(page) )

	    # Build JSON Decoder and decode the JSON result into a
	    # Dictionary
        
        jsonDictionary = getJSONResponse(f)
        
        result = []
        
        for twitt in jsonDictionary['results']:
            result.append(twitt[TEXT_FIELD])
            
        f.close()
        
        return result


    def showStatus( self, user ):
	    
	    f = urlopen(SEARCH_USR_URL % 'json' + user )

	    jsonDictionary = getJSONResponse( f )
	    
	    f.close()

	    if jsonDictionary[PROTECTED_FIELD] is True:
		    print 'Protected Status: Must call showProtectedStatus'
		    return

	    return jsonDictionary[STATUS_FIELD][TEXT_FIELD]
   

class CataAuthTwitUser(CataTwitUser):
    
    user = ""
    
    password = ""
    
    def __init__(self, user, password):
        self.user = user
        self.password = password
        
    def updateStatus( self, status ):
    
        params = urlencode({'status':status})
        
        response = self.__sendPostToResource( params, SEND_DIRECT_MS_RESOURCE, 'json' )

        return 
    
    def sendDirectMessage( self, toUser, msg ):

        params = urlencode({'user':toUser, 'text':msg})
       
        response = self.__sendPostToResource( params, SEND_DIRECT_MSG_RESOURCE, 'json' )

        return response


    def getSentDirectMessages( self, howMany ):

        response = self.__sendGetToURL( GET_DIRECT_MSGS_SENT + "?count=" + str(howMany), 'json' )

        strRes = response.read()
        
        jsonDec = JSONDecoder()

        res = jsonDec.decode(strRes)
       
        ret = []

        for msg in res:
            ret.append(msg[TEXT_FIELD])    

        return ret


    def showStatus( self, user ):
    
        response = self.__sendGetToURL( USR_STATUS_RESOURCE + user, 'json' ) 

        str = response.read()
        
        jsonDec = JSONDecoder()

        ret = jsonDec.decode(str)

        if ret[PROTECTED_FIELD] is True and not ret.has_key(STATUS_FIELD):
            print( 'You are not friend of this Protected Twitter User.')
            return
        
        return jsonDec.decode(str)[STATUS_FIELD][TEXT_FIELD]

    def __sendPostToResource( self, params, resource, responseFormat ):

        basicAuthString = "Basic " + base64.encodestring(self.user + ":" + self.password)
        
        basicAuthString = basicAuthString.replace("\n", "")

        
        headers = { "Authorization":basicAuthString, "Host":TWITTER_HOST }
        
        conn = HTTPConnection(TWITTER_HOST + ":" + PORT)
        
        conn.request( "POST", resource % "json", params, headers )
        
        response = conn.getresponse()

        if response.status != 200:
            print ('Request Failed. Error code: %s. ' % str(response.status)
            + 'Reason: ' + response.reason)
            return

        return response

    def __sendGetToURL( self, url, responseFormat ):

        basicAuthString = "Basic " + base64.encodestring(self.user + ":" + self.password)
        
        basicAuthString = basicAuthString.replace("\n", "")

        conn = HTTPConnection(TWITTER_HOST + ":" + PORT)

        conn.putrequest( "GET", url % "json" )

        conn.putheader("Authorization", basicAuthString)

        conn.putheader("Host", TWITTER_HOST)

        conn.endheaders()

        response = conn.getresponse()

        if response.status != 200:
            print ('Status not retrieved. Error code: %s. ' % str(response.status)
            + 'Reason: ' + response.reason)
            return

        return response

### Auxiliar Functions ###


def getJSONResponse( file ):

    # Build JSON Decoder and decode the JSON result into a
    # Dictionary
    
    jsonString = file.readlines()[0]

    jsonDecoder = JSONDecoder()

    jsonDictionary = jsonDecoder.decode(jsonString)

    if isinstance(jsonDictionary, dict) and jsonDictionary.has_key('error'):
        print "Error: " + jsonDictionary['error']
        return
    
    return jsonDictionary


def sanitizeHtml(value):
    r = re.compile(r'[\s]*(&#x.{1,7})?'.join(list('javascript:')))
    validTags = 'p i strong b u a h1 h2 h3 pre br img'.split()
    validAttrs = 'href src'.split()
    soup = BeautifulSoup(value)
    for comment in soup.findAll(text=lambda text: isinstance(text, Comment)):
        comment.extract()
    for tag in soup.findAll(True):
        if tag.name not in validTags:
            tag.hidden = True
        tag.attrs = [(attr, r.sub('', val)) for attr, val in tag.attrs
                     if attr in validAttrs]
    return soup.renderContents().decode('utf8')

