USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Kolorniki","/go/_category/?idc=%2258_12381%22"))
aux2 = insFld(aux1, gFld("Zêby","/go/_category/?idc=%2258_12368%22"))
insDoc(aux2, gLnk("S","Boczne","/go/_category/?idc=%2258_12368_369%22"))
insDoc(aux2, gLnk("S","Przednie","/go/_category/?idc=%2258_12368_370%22"))
