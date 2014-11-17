USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_51%22"))
aux2 = insFld(aux1, gFld("Endodoncja","/go/_category/?idc=%2251_12266%22"))
insDoc(aux2, gLnk("S","Lentulo","/go/_category/?idc=%2251_12266_357%22"))
insDoc(aux2, gLnk("S","Upychad³a do gutaperki","/go/_category/?idc=%2251_12266_268%22"))
