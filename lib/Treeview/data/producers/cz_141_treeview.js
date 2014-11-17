USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_50%22"))
insDoc(aux1, gLnk("S","Lakier pokrywajacy","/go/_category/?idc=%2250_12356%22"))
insDoc(aux1, gLnk("S","P³ytki szelakowe","/go/_category/?idc=%2250_12308%22"))
aux2 = insFld(aux1, gFld("Zêby","/go/_category/?idc=%2250_12261%22"))
insDoc(aux2, gLnk("S","Boczne","/go/_category/?idc=%2250_12261_256%22"))
insDoc(aux2, gLnk("S","Przednie","/go/_category/?idc=%2250_12261_257%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_51%22"))
aux2 = insFld(aux1, gFld("Masy wyciskowe","/go/_category/?idc=%2251_12276%22"))
insDoc(aux2, gLnk("S","Alginatowe","/go/_category/?idc=%2251_12276_267%22"))
insDoc(aux2, gLnk("S","Inne","/go/_category/?idc=%2251_12276_301%22"))
insDoc(aux2, gLnk("S","Silikonowe","/go/_category/?idc=%2251_12276_274%22"))
insDoc(aux1, gLnk("S","Wype³nienia","/go/_category/?idc=%2251_12264%22"))
