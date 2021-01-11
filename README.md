# YuDrive
Open https://console.developers.google.com and login to your account


Click Select a Project


Click New Project


fill in the fields provided


the project was successfully created and then click your project

Then, goto Dashboard and click ENABLE APIS AND SERVICES


Search “Google Drive API” and “Google Picker API”

ENABLE it


ENABLE it
Open Credential menu and goto Domain verification tab, there please follow the instructions from google

Goto OAuth consent screen tab and follow it like this

Still in OAuth consent screen, click Add scope and thick this and then Save

Goto Credentials tab, and first, click API key and then click OAuth client ID

follow it like this, replace it with your domain name. And Save

API Key and Client ID successfully created

And now please configure it in the script
_______________________________________________________________________________________________________________________

EN
--------------
For the login system there are two methods
(1) first, by using the OAuth token prompt and copy paste the token.
(2) second, login automatically without copying the token.

The following tutorial on making API is for the first method (1).
if you want to use the second method of making almost the same, the difference in the 7th image select Application type "Web Application"
and fill in the Authorized redirect URIs by https://yourdomain.com/OAuth

but for the second way you must need an Google API that is already verified
