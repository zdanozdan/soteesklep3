USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Dezynfekcja i Higiena","/go/_category/?idc=%22id_60%22"))
insDoc(aux1, gLnk("S","Dezynfekcja powierzchni i narzêdzi","/go/_category/?idc=%2260_12419%22"))
insDoc(aux1, gLnk("S","Dezynfekcja r±k i skóry","/go/_category/?idc=%2260_12418%22"))
insDoc(aux1, gLnk("S","Dozowniki , podajniki, pojemniki","/go/_category/?idc=%2260_12412%22"))
aux1 = insFld(foldersTree, gFld("Higiena jamy ustnej","/go/_category/?idc=%22id_61%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Urz±dzenia","/go/_category/?idc=%2258_12380%22"))
insDoc(aux1, gLnk("S","Woreczki strunowe","/go/_category/?idc=%2258_12446%22"))
