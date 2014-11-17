USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
aux2 = insFld(aux1, gFld("Odbudowa zêbów","/go/_category/?idc=%2259_12393%22"))
insDoc(aux2, gLnk("S","Kliny","/go/_category/?idc=%2259_12393_407%22"))
insDoc(aux2, gLnk("S","Paski,ta¶my,formówki","/go/_category/?idc=%2259_12393_385%22"))
