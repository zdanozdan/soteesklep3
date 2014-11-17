USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_50%22"))
aux2 = insFld(aux1, gFld("Akryle","/go/_category/?idc=%2250_12270%22"))
insDoc(aux2, gLnk("S","Meliodent","/go/_category/?idc=%2250_12270_269%22"))
insDoc(aux2, gLnk("S","Paladent","/go/_category/?idc=%2250_12270_325%22"))
insDoc(aux2, gLnk("S","Paladon","/go/_category/?idc=%2250_12270_334%22"))
