USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
aux2 = insFld(aux1, gFld("Metale","/go/_category/?idc=%2232_12085%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2232_12085_45%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2232_12085_44%22"))
