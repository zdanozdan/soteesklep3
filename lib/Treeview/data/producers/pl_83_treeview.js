USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_41%22"))
insDoc(aux1, gLnk("S","P³ytki szelakowe","/go/_category/?idc=%2241_12194%22"))
aux2 = insFld(aux1, gFld("Zêby","/go/_category/?idc=%2241_12148%22"))
insDoc(aux2, gLnk("S","Boczne","/go/_category/?idc=%2241_12148_138%22"))
insDoc(aux2, gLnk("S","Przednie","/go/_category/?idc=%2241_12148_139%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_42%22"))
aux2 = insFld(aux1, gFld("Masy wyciskowe","/go/_category/?idc=%2242_12162%22"))
insDoc(aux2, gLnk("S","Alginatowe","/go/_category/?idc=%2242_12162_148%22"))
insDoc(aux2, gLnk("S","Inne","/go/_category/?idc=%2242_12162_180%22"))
insDoc(aux2, gLnk("S","Silikonowe","/go/_category/?idc=%2242_12162_155%22"))
insDoc(aux1, gLnk("S","Wype³nienia","/go/_category/?idc=%2242_12151%22"))
