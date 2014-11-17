USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_50%22"))
aux2 = insFld(aux1, gFld("Porcelana","/go/_category/?idc=%2250_12262%22"))
insDoc(aux2, gLnk("S","IPS d.SIGN","/go/_category/?idc=%2250_12262_315%22"))
insDoc(aux2, gLnk("S","IPS InLine","/go/_category/?idc=%2250_12262_363%22"))
insDoc(aux1, gLnk("S","Zêby","/go/_category/?idc=%2250_12261%22"))
