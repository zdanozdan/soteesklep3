USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
aux2 = insFld(aux1, gFld("Materia�y i elementy protez","/go/_category/?idc=%2232_12058%22"))
aux3 = insFld(aux2, gFld("Akryle","/go/_category/?idc=%2232_12058_27%22"))
insDoc(aux3, gLnk("S","Meliodent","/go/_category/?idc=%2232_12058_27_26%22"))
insDoc(aux3, gLnk("S","Paladent","/go/_category/?idc=%2232_12058_27_57%22"))
insDoc(aux3, gLnk("S","Paladon","/go/_category/?idc=%2232_12058_27_60%22"))
