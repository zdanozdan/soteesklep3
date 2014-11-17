USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Medyczne","/go/_category/?idc=%22id_46%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_42%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2242_12164%22"))
insDoc(aux1, gLnk("S","Endodoncja","/go/_category/?idc=%2242_12153%22"))
insDoc(aux1, gLnk("S","Preparaty stomatologiczne","/go/_category/?idc=%2242_12175%22"))
