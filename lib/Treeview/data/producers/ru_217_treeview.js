USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
aux2 = insFld(aux1, gFld("Masy os³aniaj±ce","/go/_category/?idc=%2258_12399%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2258_12399_390%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2258_12399_389%22"))
insDoc(aux1, gLnk("S","Metale","/go/_category/?idc=%2258_12398%22"))
insDoc(aux1, gLnk("S","Urz±dzenia","/go/_category/?idc=%2258_12380%22"))
