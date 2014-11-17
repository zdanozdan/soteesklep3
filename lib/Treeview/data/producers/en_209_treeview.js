USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Dezynfekcja i Higiena","/go/_category/?idc=%22id_60%22"))
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_62%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2259_12385%22"))
insDoc(aux1, gLnk("S","Endodoncja","/go/_category/?idc=%2259_12373%22"))
insDoc(aux1, gLnk("S","Narzêdzia i instrumenty stomatologiczne","/go/_category/?idc=%2259_12387%22"))
aux2 = insFld(aux1, gFld("Odbudowa zêbów","/go/_category/?idc=%2259_12393%22"))
insDoc(aux2, gLnk("S","Kliny","/go/_category/?idc=%2259_12393_407%22"))
insDoc(aux2, gLnk("S","Paski,ta¶my,formówki","/go/_category/?idc=%2259_12393_385%22"))
insDoc(aux1, gLnk("S","Wype³nienia czasowe","/go/_category/?idc=%2259_12397%22"))
