EasyUpload
Developed for Graham Glass, http://www.edu20.org
04-August-2006

This plugin for FCKeditor provides three buttons to make it easy for new users
to upload pictures or files as well as creating external links.
The dialogs are based on the default Image and Link dialogs, but everything 
that wasn't extrictly neccesary has been removed so the users are able to work
without any previous knowledge.

To add it to your installation, extract the contents under the plugins folder.
Now in your fckconfig.js file add the plugin:
FCKConfig.Plugins.Add( 'easyUpload', 'en' ) ;

You can add now to the toolbar any of the three buttons that you might want to use
'easyImage','easyFile','easyLink'

For the Image and Link buttons it uses the default pictures according to your 
FCKeditor theme, and the File uses a typical paperclip picture.


example:
FCKConfig.ToolbarSets["Default"] = [
    ['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
    '/',
    ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
    ['OrderedList','UnorderedList','-','Outdent','Indent'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
    ['Link','Unlink','Anchor'],
    ['Image','Flash','Table','Rule','Smiley','SpecialChar','PageBreak','UniversalKey'],
    '/',
    ['Style','FontFormat','FontName','FontSize'],
    ['TextColor','BGColor'],
    ['FitWindow','-','About']
     ,['easyImage','easyFile','easyLink']
] ;

If you add the new buttons you might want to remove the default Image and Link
options and replace with these ones.


Then you need to specify the language that you'll use to process the uploaded files:

var _QuickUploadLanguage    = 'asp' ;    // asp | aspx | cfm | lasso | php YOUR LANGUAGE


And if you find it neccesary adjust the path to the upload script or the 
extensions that will be processed at the client side to allow or reject the
file before it is uploaded.

FCKConfig.LinkUploadURL = FCKConfig.BasePath + 'filemanager/upload/' + _QuickUploadLanguage + '/upload.' + _QuickUploadLanguage  + '?Type=File' ;
FCKConfig.LinkUploadAllowedExtensions    = "" ;            // empty for all
FCKConfig.LinkUploadDeniedExtensions    = ".(php|php3|php5|phtml|asp|aspx|ascx|jsp|cfm|cfc|pl|bat|exe|dll|reg|cgi)$" ;    // empty for no one

FCKConfig.ImageUploadURL = FCKConfig.BasePath + 'filemanager/upload/' + _QuickUploadLanguage + '/upload.' + _QuickUploadLanguage + '?Type=Image' ;
FCKConfig.ImageUploadAllowedExtensions    = ".(jpg|gif|jpeg|png)$" ;        // empty for all
FCKConfig.ImageUploadDeniedExtensions    = "" ;                            // empty for no one


Finally:
You must enable the uploader script under filemanager/upload/ YOUR LANGUAGE 
and check there that the allowed and denied extensions match your needs. You
can also adjust in that script the place were the files will be saved (by 
default all the files are saved at the root of the user files directory, 
there's no distinction (in 2.3.1) according to the type (Image, File)



The plugin provides the context menu entries for link and image elements, so
you might also remove those ones from you configuration:

FCKConfig.ContextMenu = ['Generic','Anchor','Flash','Select','Textarea','Checkbox','Radio','TextField','HiddenField','ImageButton','Button','BulletedList','NumberedList','Table','Form'] ;

