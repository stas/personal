import javax.swing.*;
import java.awt.*;
public class Main extends JFrame {
	public void showImage() {
		JFrame frame = new JFrame("O fereastra");
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setSize(600, 500);
		frame.setResizable(false);
		frame.setLocationRelativeTo(null);

		String imgStr = "logo_ohs.jpg";

		ImageIcon image = new ImageIcon(imgStr);
		JLabel label1 = new JLabel(" ", image, JLabel.CENTER);
		frame.getContentPane().add(label1);

		frame.validate();
		frame.setVisible(true);
	}
	public static void main(String[] args) {
		Main show1 = new Main();
		show1.showImage();
	}
}
