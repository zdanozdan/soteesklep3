USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Gipsy","/go/_category/?idc=%2258_12427%22"))
insDoc(aux1, gLnk("S","Preparaty do gipsu , wosku","/go/_category/?idc=%2258_12404%22"))
insDoc(aux1, gLnk("S","Tworzywo akrylowe","/go/_category/?idc=%2258_12479%22"))
insDoc(aux1, gLnk("S","Woski","/go/_category/?idc=%2258_12392%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Cementy i podkłady","/go/_category/?idc=%2259_12385%22"))
insDoc(aux1, gLnk("S","Materiały łączące","/go/_category/?idc=%2259_12411%22"))
insDoc(aux1, gLnk("S","Preparaty do nadwrażliwości","/go/_category/?idc=%2259_12376%22"))
aux2 = insFld(aux1, gFld("Wypełnienia","/go/_category/?idc=%2259_12371%22"))
insDoc(aux2, gLnk("S","Glassjonomery","/go/_category/?idc=%2259_12371_481%22"))
insDoc(aux2, gLnk("S","Światłoutwardzalne","/go/_category/?idc=%2259_12371_403%22"))
