USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_34%22"))
aux2 = insFld(aux1, gFld("Wype³nienia","/go/_category/?idc=%2234_12063%22"))
aux3 = insFld(aux2, gFld("?wiat³outwardzalne","/go/_category/?idc=%2234_12063_81%22"))
insDoc(aux3, gLnk("S","System Filtek","/go/_category/?idc=%2234_12063_81_64%22"))
insDoc(aux3, gLnk("S","System Valux","/go/_category/?idc=%2234_12063_81_56%22"))
