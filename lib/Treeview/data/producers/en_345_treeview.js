USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
aux2 = insFld(aux1, gFld("Odbudowa zêbów","/go/_category/?idc=%2259_12393%22"))
insDoc(aux2, gLnk("S","Æwieki oko³omiazgowe","/go/_category/?idc=%2259_12393_439%22"))
insDoc(aux2, gLnk("S","Wk³ady koronowo-korzeniowe","/go/_category/?idc=%2259_12393_392%22"))
