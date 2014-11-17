USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Medyczne","/go/_category/?idc=%22id_55%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_51%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2251_12278%22"))
insDoc(aux1, gLnk("S","Endodoncja","/go/_category/?idc=%2251_12266%22"))
insDoc(aux1, gLnk("S","Preparaty stomatologiczne","/go/_category/?idc=%2251_12289%22"))
