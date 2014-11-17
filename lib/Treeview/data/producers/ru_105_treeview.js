USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("&#1042;&#1099;&#1073;&#1077;&#1088;&#1080; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1102;","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_42%22"))
aux2 = insFld(aux1, gFld("Endodoncja","/go/_category/?idc=%2242_12153%22"))
insDoc(aux2, gLnk("S","Lentulo","/go/_category/?idc=%2242_12153_235%22"))
insDoc(aux2, gLnk("S","Upychad³a do gutaperki","/go/_category/?idc=%2242_12153_149%22"))
