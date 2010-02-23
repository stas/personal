#!/usr/bin/env python
import gtk
class UnButon:
	def __init__(self):
		self.window = gtk.Window(gtk.WINDOW_TOPLEVEL)
		self.window.set_size_request(300, 200)
		self.window.set_position(gtk.WIN_POS_CENTER)
		self.button = gtk.Button("Bine ai venit la Open High School")
		self.button.connect("clicked", gtk.main_quit)
		self.window.add(self.button)
		self.window.show_all()
	def main(self):
		gtk.main()

exemplu = UnButon()
exemplu.main()
