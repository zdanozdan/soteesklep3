USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("&#1042;&#1099;&#1073;&#1077;&#1088;&#1080; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1102;","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_34%22"))
aux2 = insFld(aux1, gFld("Wypełnienia","/go/_category/?idc=%2234_12063%22"))
aux3 = insFld(aux2, gFld("?wiatłoutwardzalne","/go/_category/?idc=%2234_12063_81%22"))
insDoc(aux3, gLnk("S","System Filtek","/go/_category/?idc=%2234_12063_81_64%22"))
insDoc(aux3, gLnk("S","System Valux","/go/_category/?idc=%2234_12063_81_56%22"))
