USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
aux2 = insFld(aux1, gFld("Endodoncja","/go/_category/?idc=%2259_12373%22"))
insDoc(aux2, gLnk("S","D Finders","/go/_category/?idc=%2259_12373_472%22"))
insDoc(aux2, gLnk("S","Lentulo","/go/_category/?idc=%2259_12373_468%22"))
insDoc(aux2, gLnk("S","Miazgoci±gi","/go/_category/?idc=%2259_12373_383%22"))
insDoc(aux2, gLnk("S","Pilniki","/go/_category/?idc=%2259_12373_452%22"))
insDoc(aux2, gLnk("S","Poszerzacze","/go/_category/?idc=%2259_12373_382%22"))
insDoc(aux2, gLnk("S","RT Files","/go/_category/?idc=%2259_12373_471%22"))
