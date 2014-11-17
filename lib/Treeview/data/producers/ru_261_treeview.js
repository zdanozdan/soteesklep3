USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
aux2 = insFld(aux1, gFld("Systemy do polerowania","/go/_category/?idc=%2259_12375%22"))
insDoc(aux2, gLnk("S","Gumki","/go/_category/?idc=%2259_12375_375%22"))
insDoc(aux2, gLnk("S","Kr±¿ki","/go/_category/?idc=%2259_12375_419%22"))
insDoc(aux2, gLnk("S","Mandrylki","/go/_category/?idc=%2259_12375_420%22"))
