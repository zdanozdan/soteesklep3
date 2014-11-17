USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_62%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Akryle","/go/_category/?idc=%2258_12377%22"))
insDoc(aux1, gLnk("S","Akryle do licowania","/go/_category/?idc=%2258_12438%22"))
insDoc(aux1, gLnk("S","Farby opakerowe","/go/_category/?idc=%2258_12485%22"))
insDoc(aux1, gLnk("S","Kolorniki","/go/_category/?idc=%2258_12381%22"))
insDoc(aux1, gLnk("S","Porcelana","/go/_category/?idc=%2258_12369%22"))
insDoc(aux1, gLnk("S","Szczotki , Filce","/go/_category/?idc=%2258_12402%22"))
insDoc(aux1, gLnk("S","Urz±dzenia","/go/_category/?idc=%2258_12380%22"))
insDoc(aux1, gLnk("S","Woski","/go/_category/?idc=%2258_12392%22"))
aux2 = insFld(aux1, gFld("Zêby","/go/_category/?idc=%2258_12368%22"))
insDoc(aux2, gLnk("S","Boczne","/go/_category/?idc=%2258_12368_369%22"))
insDoc(aux2, gLnk("S","Przednie","/go/_category/?idc=%2258_12368_370%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
