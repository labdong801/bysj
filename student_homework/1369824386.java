import java.net.*;
import java.io.*;

public class UDPServer {
	public static void main(String args[]) throws Exception {
		//先创建一个包
		byte[] buf = new byte[1024];
		DatagramPacket dp = new DatagramPacket(buf,buf.length);
		
		//创建接收UDP客户端发送过来的信息
		DatagramSocket ds = new DatagramSocket(50001);
		
		while(true){
			ds.receive(dp);
		
		}
	}
}