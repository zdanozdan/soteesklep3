USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_62%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Silikony","/go/_category/?idc=%2258_12424%22"))
insDoc(aux1, gLnk("S","Urz±dzenia","/go/_category/?idc=%2258_12380%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Accessories","/go/_category/?idc=%2259_12389%22"))
aux2 = insFld(aux1, gFld("Masy wyciskowe","/go/_category/?idc=%2259_12383%22"))
insDoc(aux2, gLnk("S","Akcesoria do mas","/go/_category/?idc=%2259_12383_393%22"))
insDoc(aux2, gLnk("S","Alginatowe","/go/_category/?idc=%2259_12383_380%22"))
insDoc(aux2, gLnk("S","Silikonowe","/go/_category/?idc=%2259_12383_387%22"))
