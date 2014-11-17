USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
aux2 = insFld(aux1, gFld("Endodoncja","/go/_category/?idc=%2259_12373%22"))
insDoc(aux2, gLnk("S","Leczenie kana³owe","/go/_category/?idc=%2259_12373_480%22"))
insDoc(aux2, gLnk("S","Wype³nianie kana³u","/go/_category/?idc=%2259_12373_479%22"))
