USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
aux2 = insFld(aux1, gFld("Materia�y jednorazowe","/go/_category/?idc=%2259_12478%22"))
insDoc(aux2, gLnk("S","Kompresy, przylepce, banda�e","/go/_category/?idc=%2259_12478_502%22"))
insDoc(aux2, gLnk("S","Wa�eczki,lignina","/go/_category/?idc=%2259_12478_495%22"))
