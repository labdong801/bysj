import java.net.*;
import java.io.*;

public class UDPServer {
	public static void main(String args[]) throws Exception {
		//�ȴ���һ����
		byte[] buf = new byte[1024];
		DatagramPacket dp = new DatagramPacket(buf,buf.length);
		
		//��������UDP�ͻ��˷��͹�������Ϣ
		DatagramSocket ds = new DatagramSocket(50001);
		
		while(true){
			ds.receive(dp);
		
		}
	}
}