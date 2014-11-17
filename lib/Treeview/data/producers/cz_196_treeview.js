USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Dezynfekcja i Higiena","/go/_category/?idc=%22id_60%22"))
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_62%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Akryle","/go/_category/?idc=%2258_12377%22"))
insDoc(aux1, gLnk("S","Gipsy","/go/_category/?idc=%2258_12427%22"))
insDoc(aux1, gLnk("S","Materia³y do pod¶cieleñ","/go/_category/?idc=%2258_12433%22"))
aux2 = insFld(aux1, gFld("Materia³y polerskie","/go/_category/?idc=%2258_12370%22"))
insDoc(aux2, gLnk("S","Pasta polerska","/go/_category/?idc=%2258_12370_372%22"))
insDoc(aux2, gLnk("S","Pumeks","/go/_category/?idc=%2258_12370_405%22"))
insDoc(aux1, gLnk("S","Narzêdzia do modelowania","/go/_category/?idc=%2258_12401%22"))
insDoc(aux1, gLnk("S","Preparaty do gipsu , wosku","/go/_category/?idc=%2258_12404%22"))
insDoc(aux1, gLnk("S","Tworzywo akrylowe","/go/_category/?idc=%2258_12479%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Doplòky","/go/_category/?idc=%2259_12389%22"))
insDoc(aux1, gLnk("S","Masy wyciskowe","/go/_category/?idc=%2259_12383%22"))
insDoc(aux1, gLnk("S","Matreria³y do pod¶cieleñ","/go/_category/?idc=%2259_12469%22"))
insDoc(aux1, gLnk("S","Wype³nienia czasowe","/go/_category/?idc=%2259_12397%22"))
