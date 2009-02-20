/*
 * Created on Apr 27, 2007
 */

package org.jtw.ui.cli;

import java.io.IOException;
import java.io.InputStream;
import java.text.ParseException;
import javax.xml.parsers.ParserConfigurationException;

import org.xml.sax.SAXException;


import org.jtw.ui.JTwittConfig;
import org.jtwitterlib.net.TwitterConnection;
import org.jtwitterlib.xml.TwitterXMLParser;

/**
 * @author Lukasz Grzegorz Maciak
 *
 */
public class JTwittCli
{

	/**
	 * @param args
	 */
	public static void main(String[] args)
	{
		JTwittConfig conf = new JTwittConfig();
		conf.loadConfig();
	
		try
		{
						
			
			InputStream s = TwitterConnection.getFriendsTimelineStream(conf.getUsername(), conf.getPassword());
			
			
			//System.out.println(s);
			
			TwitterXMLParser p = new TwitterXMLParser();
			
			p.parse(s);
						
			//System.out.println(p.getNumberOfItems());
			
			for(int i=0; i<p.getNumberOfItems(); i++)
			{
				System.out.println(p.getItemAt(i) + "\n\n");
			}
			
		}
		catch (IOException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		catch (SAXException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		catch (ParserConfigurationException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		catch (ParseException e)
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		

	}

}
