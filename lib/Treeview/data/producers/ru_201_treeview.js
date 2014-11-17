USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Grubo¶ciomierze","/go/_category/?idc=%2258_12426%22"))
insDoc(aux1, gLnk("S","Kamienie , Tarcze , Separatory","/go/_category/?idc=%2258_12406%22"))
insDoc(aux1, gLnk("S","Pi³ki,brzeszczoty","/go/_category/?idc=%2258_12425%22"))
insDoc(aux1, gLnk("S","Urz±dzenia","/go/_category/?idc=%2258_12380%22"))
insDoc(aux1, gLnk("S","Woreczki strunowe","/go/_category/?idc=%2258_12446%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2258_12392%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2258_12392_388%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2258_12392_391%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Endodoncja","/go/_category/?idc=%2259_12373%22"))
insDoc(aux1, gLnk("S","Sterylizacja","/go/_category/?idc=%2259_12481%22"))
insDoc(aux1, gLnk("S","Wype³nienia","/go/_category/?idc=%2259_12371%22"))
