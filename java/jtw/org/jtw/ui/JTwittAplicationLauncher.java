/*
 * Created on Jun 30, 2007
 */

package org.jtw.ui;

import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.UIManager;
import javax.swing.UnsupportedLookAndFeelException;
import org.jtw.ui.gui.JTWGui;

/**
 * Default JTW Gui launcher.
 * @author Lukasz Grzegorz Maciak
 * @author modified by Stas SUHKOV (stas@nerd.ro)
 */
public class JTwittAplicationLauncher
{

	/**
	 * @param args
	 */
	public static void main(String[] args)
	{
        try {
            // Set System L&F
            UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(JTwittAplicationLauncher.class.getName()).log(Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            Logger.getLogger(JTwittAplicationLauncher.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            Logger.getLogger(JTwittAplicationLauncher.class.getName()).log(Level.SEVERE, null, ex);
        } catch (UnsupportedLookAndFeelException ex) {
            Logger.getLogger(JTwittAplicationLauncher.class.getName()).log(Level.SEVERE, null, ex);
        }

		new JTWGui().setVisible(true);
	}

}
